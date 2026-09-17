import { Tabs } from 'expo-router';
import { Ionicons } from '@expo/vector-icons';
import { Platform, View, StyleSheet, Animated } from 'react-native';
import React, { useEffect, useRef } from 'react';

type TabIconProps = {
  name: keyof typeof Ionicons.glyphMap;
  focused: boolean;
  color: string;
};

const TabIcon = ({ name, focused, color }: TabIconProps) => {
  const scale = useRef(new Animated.Value(focused ? 1 : 0)).current;

  useEffect(() => {
    Animated.timing(scale, {
      toValue: focused ? 1 : 0,
      duration: 150,
      useNativeDriver: true,
    }).start();
  }, [focused]);

  const iconScale = scale.interpolate({
    inputRange: [0, 1],
    outputRange: [1, 1.08]
  });

  const bgOpacity = scale.interpolate({
    inputRange: [0, 1],
    outputRange: [0, 1]
  });

  return (
    <View style={styles.iconContainer}>
      <Animated.View style={[styles.activeBackground, { opacity: bgOpacity }]} />
      <Animated.View style={{ transform: [{ scale: iconScale }] }}>
        <Ionicons name={name} size={23} color={color} />
      </Animated.View>
    </View>
  );
};

export default function TabLayout() {
  return (
    <Tabs
      screenOptions={{
        headerShown: false,
        tabBarActiveTintColor: '#E6392F', // Fire Red/Orange
        tabBarInactiveTintColor: '#737373', // Muted Text
        tabBarStyle: {
          backgroundColor: '#FFFFFF',
          borderTopWidth: 1,
          borderTopColor: '#F5F5F5',
          position: 'absolute',
          elevation: 16,
          shadowColor: '#000',
          shadowOffset: { width: 0, height: -4 },
          shadowOpacity: 0.04,
          shadowRadius: 12,
          paddingBottom: Platform.OS === 'ios' ? 28 : 12,
          paddingTop: 8,
          minHeight: Platform.OS === 'ios' ? 88 : 70,
        },
        tabBarLabelStyle: {
          fontSize: 11,
          fontWeight: '600',
          marginTop: 2,
        },
      }}>
      <Tabs.Screen
        name="index"
        options={{
          title: 'Home',
          tabBarIcon: ({ color, focused }) => (
            <TabIcon name={focused ? "home" : "home-outline"} focused={focused} color={color} />
          ),
        }}
      />
      <Tabs.Screen
        name="todays-plan"
        options={{
          title: 'Tasks',
          tabBarIcon: ({ color, focused }) => (
            <TabIcon name={focused ? "checkmark-circle" : "checkmark-circle-outline"} focused={focused} color={color} />
          ),
        }}
      />
      <Tabs.Screen
        name="schedule"
        options={{
          href: null,
          title: 'Schedule',
          tabBarIcon: ({ color, focused }) => (
            <TabIcon name={focused ? "calendar" : "calendar-outline"} focused={focused} color={color} />
          ),
        }}
      />
      <Tabs.Screen
        name="your-team"
        options={{
          title: 'Team',
          tabBarIcon: ({ color, focused }) => (
            <TabIcon name={focused ? "people" : "people-outline"} focused={focused} color={color} />
          ),
        }}
      />
      <Tabs.Screen
        name="tools-operations"
        options={{
          title: 'More',
          tabBarIcon: ({ color, focused }) => (
            <TabIcon name={focused ? "grid" : "grid-outline"} focused={focused} color={color} />
          ),
        }}
      />
    </Tabs>
  );
}

const styles = StyleSheet.create({
  iconContainer: {
    width: 36,
    height: 36,
    alignItems: 'center',
    justifyContent: 'center',
  },
  activeBackground: {
    ...StyleSheet.absoluteFillObject,
    backgroundColor: '#FFF0ED',
    borderRadius: 18,
  }
});
